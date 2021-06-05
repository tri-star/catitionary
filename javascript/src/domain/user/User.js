import { constraints } from '@/lib/validator/constraints'
import { RuleCollection } from '@/lib/validator/Rule'

export class User {
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
        length: constraints.maxLength(255),
      },
      loginId: {
        required: constraints.required(),
        length: constraints.maxLength(15),
        // uniqueLoginId: {
        //   asyncRule: this.uniqueLoginId(),
        // },
      },
      password: {
        required: constraints.required(),
        length: constraints.betweenLength(8, 1000),
      },
      confirmPassword: {
        same: constraints.same('password', 'パスワード'),
      },
    }
  }

  uniqueLoginId() {
    return async (value, parameters, input, context) => {
      const excludeId = context['selfId']
      const okResponse = {
        ok: true,
      }
      const errorResponse = {
        ok: false,
        message: '既に使用されているログインIDです。',
      }

      const isExist = await this.userRepository.isLoginIdExist(value, excludeId)
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
