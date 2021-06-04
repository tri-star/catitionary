import { constraints } from '@/lib/validator/constraints'
import { RuleCollection } from '@/lib/validator/Rule'

export class User {
  constructor(params) {
    this.id = params?.id ?? 0
    this.loginId = params?.loginId ?? ''
    this.name = params?.name ?? ''
  }
}

export class UserRegisterRequest {
  constructor(params) {
    this.id = params?.id ?? 0
    this.name = params?.name ?? 0
    this.loginId = params?.loginId ?? 0
  }

  /**
   * @returns {User}
   */
  toEntity() {
    return new User({
      id: this.id,
      name: this.name,
      loginId: this.loginId,
    })
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
      name: {
        required: constraints.required(),
        length: constraints.maxLength(15),
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
