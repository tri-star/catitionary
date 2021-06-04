import { reactive } from '@vue/composition-api'
import { useValidator } from '@/hooks/useValidator'
import { UserRegisterRuleCollection } from '@/domain/user/User'

export class RegisterPageStore {
  constructor(userRepository) {
    this.state = {}

    this.validator = useValidator()
    this.userRepository = userRepository
    this.ruleCollection = new UserRegisterRuleCollection(null)
  }

  initialize() {
    this.state = reactive({
      form: {
        email: '',
        loginId: '',
        password: '',
        confirmPassword: '',
      },
      errors: {},
    })

    this.validator.setInitialData(this.state.form)
  }

  async validate(force = false) {
    await this.validator.validate(this.state.form, this.ruleCollection, force)
    this.state.errors = this.validator.getErrors()
    return !this.validator.isError()
  }

  async register() {
    await this.userRepository.register(this.state.form)
  }
}
