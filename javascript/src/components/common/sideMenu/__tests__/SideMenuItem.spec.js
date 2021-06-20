import { mount } from '@vue/test-utils'
import SideMenuItem from '../SideMenuItem'

describe('SideMenuItem', () => {
  const createWrapper = (id, title) => {
    return mount(SideMenuItem, {
      propsData: {
        id,
        title,
      },
    })
  }

  it('指定したタイトルが表示されること', () => {
    const expectedTitle = 'test title'
    const wrapper = createWrapper('ID', expectedTitle)
    expect(wrapper.text()).toBe(expectedTitle)
  })

  it('クリック時にイベントがemitされること', async () => {
    const expectedId = 'id'
    const wrapper = createWrapper(expectedId, 'テスト')

    const menu = wrapper.find('[data-test="menu-item"]')
    await menu.trigger('click')

    expect(wrapper.emitted('click')[0][0]).toBe(expectedId)
  })
})
