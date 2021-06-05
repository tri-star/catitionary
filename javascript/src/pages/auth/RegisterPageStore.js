import { reactive } from '@vue/composition-api'
import { useApi } from '@/hooks/useApi'
import { useValidator } from '@/hooks/useValidator'
import { UserRegisterRuleCollection } from '@/domain/user/User'
import { User } from '@/domain/user/User'

export class RegisterPageStore {
  constructor(userRepository) {
    this.state = {}

    this.validator = useValidator()
    this.userRepository = userRepository
    this.ruleCollection = new UserRegisterRuleCollection(null)
    this.userRegisterHandler = useApi(async () => {
      const user = this.createUserInstance(this.state.form)
      this.userRepository.register(user)
    })
  }

  initialize() {
    this.state = reactive({
      form: {
        email: '',
        loginId: '',
        password: '',
        confirmPassword: '',
      },
      showUserRegisteredMessage: false,
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
    if (!(await this.validate(true))) {
      return
    }

    await this.userRegisterHandler.execute()

    this.state.showUserRegisteredMessage = true
    window.setTimeout(() => {
      this.state.showUserRegisteredMessage = false
    }, 1000)
  }

  createUserInstance(data) {
    return new User({
      email: data.email,
      loginId: data.loginId,
      password: data.password,
    })
  }
}
