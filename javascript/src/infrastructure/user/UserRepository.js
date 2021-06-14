import { User } from '@/domain/user/User'
import { ResourceNotFoundError } from '@/lib/errors/ResourceNotFoundError'
import { Endpoints } from '@/constants/Endpoints'
import { ServerSideError } from '@/errors/ServerSideError'

export class UserRepository {
  constructor(axios) {
    this.axios = axios
  }

  async fetchUser(loginId) {
    const users = this.loadUsers()
    const user = users.reduce((accumlator, u) => {
      return u.loginId === loginId ? u : accumlator
    }, null)

    await new Promise((resolve) =>
      setTimeout(() => {
        resolve()
      }, 200)
    )

    return user
  }

  async fetchUserById(id) {
    const users = this.loadUsers()
    const user = users.reduce((accumlator, u) => {
      return u.id === id ? u : accumlator
    }, null)

    await new Promise((resolve) =>
      setTimeout(() => {
        resolve()
      }, 200)
    )

    if (!user) {
      throw new ResourceNotFoundError('Not Found')
    }
    return user
  }

  async isLoginIdExist(loginId, excludeId) {
    const result = await this.axios.get(Endpoints.user.isLoginIdExists, {
      params: {
        login_id: loginId,
      },
    })

    if (result.status !== 200) {
      throw new Error('ログインIDの重複確認に失敗しました')
    }

    const exists = result.data.exist ?? false
    return exists
  }

  async fetchUserList(page, pageSize, conditions) {
    const userList = new Array()

    let users = this.loadUsers()
    users = this.filterUserList(users, conditions)

    const offset = Math.max((page - 1) * pageSize, 0)
    let count = 0
    users.forEach((u) => {
      if (count++ < offset) {
        return
      }
      if (count > offset + pageSize) {
        return
      }
      userList.push(u)
    })

    await new Promise((resolve) =>
      setTimeout(() => {
        resolve()
      }, 500)
    )

    const totalCount = users.length
    return {
      userList,
      totalCount,
    }
  }

  loadUsers() {
    const users = new Array()
    const usersJson = localStorage.getItem('users')
    if (!usersJson) {
      for (let i = 0; i < 50; i++) {
        users.push(
          new User({
            id: i,
            name: `ユーザー${i}`,
            loginId: `user_${i}`,
          })
        )
      }

      localStorage.setItem('users', JSON.stringify(users))
      return users
    }

    const decodedUsers = JSON.parse(usersJson)
    for (const i in decodedUsers) {
      users.push(
        new User({
          id: decodedUsers[i]['id'] ?? 0,
          name: decodedUsers[i]['name'] ?? '',
          loginId: decodedUsers[i]['loginId'] ?? '',
        })
      )
    }
    return users
  }

  filterUserList(users, conditions) {
    const filteredUsers = users.filter((u) => {
      if (conditions['userName'] && conditions['userName'].length > 0) {
        if (!u.name.includes(String(conditions['userName']))) {
          return false
        }
      }
      if (conditions['loginId'] && conditions['loginId'].length > 0) {
        if (!u.loginId.includes(String(conditions['loginId']))) {
          return false
        }
      }
      return true
    })
    return filteredUsers
  }

  /**
   * ユーザーの登録を行う
   * @param {User} user
   */
  async register(user) {
    const result = await this.axios.post(Endpoints.user.register, {
      email: user.email,
      login_id: user.loginId,
      password: user.password,
    })
    console.log(result)
  }

  async edit(id, userData) {
    await new Promise((resolve) =>
      setTimeout(() => {
        resolve()
      }, 200)
    )
    let users = []
    const usersJson = localStorage.getItem('users')
    if (usersJson) {
      users = JSON.parse(usersJson)
    }
    const isExist = users.some((u) => {
      return (u.id ?? 0) === id
    })
    if (!isExist) {
      throw new Error(`無効なユーザーIDです: ${id}`)
    }

    users = users.map((u) => {
      if ((u.id ?? 0) !== id) {
        return u
      }
      return {
        ...userData,
        id: id,
      }
    })

    localStorage.setItem('users', JSON.stringify(users))
  }

  async verifyEmail(code) {
    try {
      await this.axios.get(Endpoints.user.verifyEmail, {
        params: {
          code,
        },
      })
    } catch (e) {
      if (e.response.status == 422) {
        return false
      }
      throw new ServerSideError(`status code=${e.response.status}`)
    }
  }
}
