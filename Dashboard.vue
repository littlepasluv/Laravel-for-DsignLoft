<template>
  <div class="dashboard">
    <!-- Loading Overlay -->
    <div 
      v-if="loading" 
      class="loading-overlay"
    >
      <p>Loading Dashboard...</p>
    </div>

    <!-- Header -->
    <header class="header">
      <div class="header-content-grid">
        <div class="header-top-row">
          <div class="logo">
            <img 
              src="https://assets.zyrosite.com/YleqxM2lNkfl3kLp/logo_dsignloft-Y4LxQ4REjXhxO2a5.svg" 
              alt="DsignLoft Logo" 
              style="width: 180px;"
            >
          </div>
          <div class="user-section">
            <div class="user-name" @click="toggleUserDropdown">{{ userName }}</div>
            <div class="profile-photo" @click="toggleUserDropdown">
              <img v-if="profilePhoto" :src="profilePhoto" alt="Profile" />
            </div>
            <div class="user-dropdown" :class="{ show: showUserDropdown }">
              <div class="dropdown-item" @click="signOut">Sign Out</div>
            </div>
          </div>
        </div>
        <div class="header-bottom-row">
          <div class="project-title-container">
            <h2>{{ projectTitle }}</h2>
          </div>
          <div class="nav-tabs">
            <div 
              v-for="tab in tabs" 
              :key="tab.id"
              class="nav-tab"
              :class="{ active: activeTab === tab.id }"
              @click="switchTab(tab.id)"
            >
              {{ tab.label }}
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="main-container">
      <!-- Brief Tab -->
      <div v-if="activeTab === 'brief'" class="tab-content active">
        <div class="info-bar">
          100% money back guarantee. 
          <a 
            href="https://dsignloft.com/dsignloft-refund-policy" 
            target="_blank" 
            rel="noopener noreferrer" 
            style="color: #53AB81; text-decoration: underline;"
          >
            Read our Terms and Conditions.
          </a>
        </div>
        <!-- Brief content will go here -->
        <BriefContent :brief-data="briefData" @update="updateBrief" />
      </div>

      <!-- Files Tab -->
      <div v-if="activeTab === 'files'" class="tab-content active">
        <FilesContent :files="files" />
      </div>

      <!-- Messages Tab -->
      <div v-if="activeTab === 'messages'" class="tab-content active">
        <MessagesContent :messages="messages" @send="sendMessage" />
      </div>

      <!-- Payment Tab -->
      <div v-if="activeTab === 'payment'" class="tab-content active">
        <PaymentContent :payment-data="paymentData" />
      </div>
    </main>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import BriefContent from './BriefContent.vue'
import FilesContent from './FilesContent.vue'
import MessagesContent from './MessagesContent.vue'
import PaymentContent from './PaymentContent.vue'

export default {
  name: 'Dashboard',
  components: {
    BriefContent,
    FilesContent,
    MessagesContent,
    PaymentContent
  },
  setup() {
    const loading = ref(true)
    const activeTab = ref('brief')
    const showUserDropdown = ref(false)
    const userName = ref('')
    const profilePhoto = ref('')
    const projectTitle = ref('Your Project Dashboard')
    const briefData = ref({})
    const files = ref([])
    const messages = ref([])
    const paymentData = ref({})

    const tabs = [
      { id: 'brief', label: 'Brief' },
      { id: 'files', label: 'Files' },
      { id: 'messages', label: 'Messages' },
      { id: 'payment', label: 'Payments' }
    ]

    const switchTab = (tabId) => {
      activeTab.value = tabId
    }

    const toggleUserDropdown = () => {
      showUserDropdown.value = !showUserDropdown.value
    }

    const signOut = () => {
      // Implement sign out logic
      console.log('Signing out...')
    }

    const updateBrief = (data) => {
      briefData.value = { ...briefData.value, ...data }
    }

    const sendMessage = (message) => {
      messages.value.push(message)
    }

    onMounted(() => {
      // Initialize dashboard data
      setTimeout(() => {
        loading.value = false
      }, 1000)
    })

    return {
      loading,
      activeTab,
      showUserDropdown,
      userName,
      profilePhoto,
      projectTitle,
      briefData,
      files,
      messages,
      paymentData,
      tabs,
      switchTab,
      toggleUserDropdown,
      signOut,
      updateBrief,
      sendMessage
    }
  }
}
</script>

<style scoped>
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.95);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
}

.user-dropdown.show {
  display: block;
}
</style>

