export const Endpoints = {
  user: {
    register: '/api/internal/auth/register',
    isLoginIdExists: '/api/internal/user/exists',
    verifyEmail: '/api/internal/auth/verify-email',
  },
  cat: {
    types: '/api/cat/types',
    characterics: '/api/cat/characterics',
  },
  name: {
    generateNames: '/api/names'
  }
}
