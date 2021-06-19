import { routes } from '@/router/routes'

export const sideMenuDefinitions = (state, router) => {
  return [
    {
      id: 'toggle',
      title: 'TOGGLE',
      click: () => {
        state.showSubMenu = !state.showSubMenu
      },
    },
    {
      id: 'register',
      title: '会員登録',
      click: () => {
        router.push({ name: routes.authRegister })
      },
    },
  ]
}
