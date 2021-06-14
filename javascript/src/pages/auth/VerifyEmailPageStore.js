import { reactive } from '@vue/composition-api'
import { ServerSideError } from '@/errors/ServerSideError'

export class VerifyEmailPageStore {
  constructor(userRepository) {
    this.userRepository = userRepository
    this.state = reactive({
      state: 'default',
    })
  }

  async verify(code) {
    if (!code) {
      return
    }

    try {
      this.state.state = 'loading'
      const succeed = await this.userRepository.verifyEmail(code)
      if (!succeed) {
        this.state.state = 'failed'
        return
      }
      this.state.state = 'complete'
    } catch (e) {
      if (e instanceof ServerSideError) {
        this.state.state = 'server-error'
      }
    }
  }
}
