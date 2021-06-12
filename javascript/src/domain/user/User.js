import { constraints } from '@/lib/validator/constraints'
import { RuleCollection } from '@/lib/validator/Rule'

export class User {
  static get MAX_EMAIL_LENGTH() {
    return 256
  }
  static get MAX_LOGIN_ID_LENGTH() {
    return 30
  }
  static get MIN_PASSWORD_LENGTH() {
    return 8
  }
  static get MAX_PASSWORD_LENGTH() {
    return 1000
  }

  constructor(params) {
    this.id = params?.id ?? 0
    this.email = params?.email ?? ''
    this.loginId = params?.loginId ?? ''
    this.password = params?.password ?? ''
  }
}

export class UserRegisterRuleCollection extends RuleCollection {
  /**
   *
   * @param {UserRepository} userRepository
   */
  constructor(userRepository) {
    super()
    this.userRepository = userRepository
    this.collection = {
      email: {
        required: constraints.required(),
        length: constraints.maxLength(User.MAX_EMAIL_LENGTH),
      },
      loginId: {
        required: constraints.required(),
        length: constraints.maxLength(User.MAX_LOGIN_ID_LENGTH),
        uniqueLoginId: {
          asyncRule: this.uniqueLoginId(),
        },
      },
      password: {
        required: constraints.required(),
        length: constraints.betweenLength(
          User.MIN_PASSWORD_LENGTH,
          User.MAX_PASSWORD_LENGTH
        ),
      },
      confirmPassword: {
        same: constraints.same('password', 'パスワード'),
      },
    }
  }

  uniqueLoginId() {
    return async (value, parameters, input, context) => {
      // const excludeId = context['selfId']
      const okResponse = {
        ok: true,
      }
      const errorResponse = {
        ok: false,
        message: '既に使用されているログインIDです。',
      }

      const isExist = await this.userRepository.isLoginIdExist(value, null)
      if (isExist) {
        return errorResponse
      }

      return okResponse
    }
  }
}

export class UserEditRuleCollection extends UserRegisterRuleCollection {
  constructor(userRepository) {
    super(userRepository)
  }
}
