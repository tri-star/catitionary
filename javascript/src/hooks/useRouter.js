import { getCurrentInstance } from '@vue/composition-api'

export function useRouter() {
  const instance = getCurrentInstance()

  if (!instance) {
    throw new Error(`Should be used in setup().`)
  }

  return instance.proxy.$router
}
