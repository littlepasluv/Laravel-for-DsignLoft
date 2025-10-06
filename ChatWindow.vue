<template>
    <div class="chat-window">
        <div class="messages" ref="messagesContainer">
            <div v-for="message in messages" :key="message.id" :class="[
                'message',
                message.sender_id === $page.props.auth.user.id ? 'sent' : 'received',
            ]">
                <strong>{{ message.sender.name }}:</strong> {{ message.message }}
            </div>
        </div>
        <form @submit.prevent="sendMessage" class="message-input">
            <input
                type="text"
                v-model="newMessage"
                placeholder="Type your message..."
                @keyup.enter="sendMessage"
            />
            <button type="submit">Send</button>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted, nextTick, onBeforeUnmount } from 'vue';
import axios from 'axios';

const props = defineProps({
    briefId: Number,
});

const messages = ref([]);
const newMessage = ref('');
const messagesContainer = ref(null);

const fetchMessages = async () => {
    try {
        const response = await axios.get(`/api/briefs/${props.briefId}/messages`);
        messages.value = response.data;
        await nextTick();
        scrollToBottom();
    } catch (error) {
        console.error('Error fetching messages:', error);
    }
};

const sendMessage = async () => {
    if (newMessage.value.trim() === '') return;

    try {
        const response = await axios.post(`/api/briefs/${props.briefId}/messages`, {
            message: newMessage.value,
        });
        // Message will be added via Echo broadcast, no need to push here
        newMessage.value = '';
        await nextTick();
        scrollToBottom();
    } catch (error) {
        console.error('Error sending message:', error);
    }
};

const scrollToBottom = () => {
    if (messagesContainer.value) {
        messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
    }
};

onMounted(() => {
    fetchMessages();

    window.Echo.private(`brief.${props.briefId}`)
        .listen('MessageSent', (e) => {
            messages.value.push(e.chatMessage);
            nextTick(() => {
                scrollToBottom();
            });
        });
});

onBeforeUnmount(() => {
    window.Echo.leave(`brief.${props.briefId}`);
});
</script>

<style scoped>
.chat-window {
    display: flex;
    flex-direction: column;
    height: 400px;
    border: 1px solid #ccc;
    border-radius: 8px;
    overflow: hidden;
}

.messages {
    flex-grow: 1;
    padding: 10px;
    overflow-y: auto;
    background-color: #f9f9f9;
}

.message {
    margin-bottom: 8px;
    padding: 6px 10px;
    border-radius: 5px;
    max-width: 80%;
}

.message.sent {
    align-self: flex-end;
    background-color: #dcf8c6;
    margin-left: auto;
}

.message.received {
    align-self: flex-start;
    background-color: #e0e0e0;
    margin-right: auto;
}

.message-input {
    display: flex;
    padding: 10px;
    border-top: 1px solid #eee;
}

.message-input input {
    flex-grow: 1;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-right: 10px;
}

.message-input button {
    padding: 8px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.message-input button:hover {
    background-color: #0056b3;
}
</style>


