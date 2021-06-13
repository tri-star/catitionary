import { Cache } from '@/lib/cache/Cache'
import { constraints } from '@/lib/validator/constraints'
import { Rule } from '@/lib/validator/Rule'
import { RuleCollection } from '@/lib/validator/RuleCollection'

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
    this.uniqueLoginIdCache = new Cache()
    this.collection = {
      email: {
        required: constraints.required(),
        length: constraints.maxLength(User.MAX_EMAIL_LENGTH),
      },
      loginId: {
        required: constraints.required(),
        length: constraints.maxLength(User.MAX_LOGIN_ID_LENGTH),
        uniqueLoginId: this.uniqueLoginId(),
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
    const func = async (value, parameters, input, context) => {
      const okResponse = {
        ok: true,
      }
      const errorResponse = {
        ok: false,
        message: '既に使用されているログインIDです。',
      }

      const isExist = await this.uniqueLoginIdCache.get(300, async () => {
        return await this.userRepository.isLoginIdExist(value, null)
      })
      if (isExist) {
        return errorResponse
      }

      return okResponse
    }
    return new Rule(func, {
      isAsync: true,
      onlyChanged: true,
    })
  }
}

export class UserEditRuleCollection extends UserRegisterRuleCollection {
  constructor(userRepository) {
    super(userRepository)
  }
}
