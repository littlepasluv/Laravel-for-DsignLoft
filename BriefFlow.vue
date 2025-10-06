<template>
  <div class="brief-flow">
    <!-- Header -->
    <div class="header">
      <div class="header-content">
        <a href="https://dsignloft.com/get-a-design" target="_blank">
          <img 
            alt="DsignLoft" 
            class="header-logo" 
            src="https://assets.zyrosite.com/YleqxM2lNkfl3kLp/logo_dsignloft-Y4LxQ4REjXhxO2a5.svg"
          />
        </a>
        <a class="header-login" href="/login" id="headerLoginBtn">Login</a>
      </div>
    </div>

    <!-- Progress Container -->
    <div class="progress-container">
      <div class="progress-bar">
        <div class="progress-steps">
          <div 
            v-for="step in steps" 
            :key="step.number"
            class="step"
            :class="{ active: currentStep === step.number }"
            :data-step="step.number"
          >
            <div class="step-number">{{ step.number }}</div>
            <span>{{ step.title }}</span>
          </div>
        </div>
        <div class="progress-line">
          <div class="progress-fill" :style="{ width: progressWidth + '%' }"></div>
        </div>
      </div>
    </div>

    <!-- Step Content -->
    <div class="step-content">
      <component 
        :is="currentStepComponent" 
        @next="nextStep" 
        @previous="previousStep"
        @update-data="updateStepData"
        :data="stepData[currentStep]"
      />
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'

export default {
  name: 'BriefFlow',
  setup() {
    const currentStep = ref(1)
    const stepData = ref({})
    
    const steps = [
      { number: 1, title: 'Logo Selection', component: 'LogoSelection' },
      { number: 2, title: 'Brand Style', component: 'BrandStyle' },
      { number: 3, title: 'Colors', component: 'Colors' },
      { number: 4, title: 'Brief Details', component: 'BriefDetails' },
      { number: 5, title: 'Package', component: 'Package' },
      { number: 6, title: 'Summary', component: 'Summary' }
    ]

    const progressWidth = computed(() => {
      return ((currentStep.value - 1) / (steps.length - 1)) * 100
    })

    const currentStepComponent = computed(() => {
      const step = steps.find(s => s.number === currentStep.value)
      return step ? step.component : 'LogoSelection'
    })

    const nextStep = () => {
      if (currentStep.value < steps.length) {
        currentStep.value++
      }
    }

    const previousStep = () => {
      if (currentStep.value > 1) {
        currentStep.value--
      }
    }

    const updateStepData = (data) => {
      stepData.value[currentStep.value] = { ...stepData.value[currentStep.value], ...data }
    }

    return {
      currentStep,
      steps,
      progressWidth,
      currentStepComponent,
      stepData,
      nextStep,
      previousStep,
      updateStepData
    }
  }
}
</script>

<style scoped>
/* Component-specific styles will be imported from the original CSS */
</style>

