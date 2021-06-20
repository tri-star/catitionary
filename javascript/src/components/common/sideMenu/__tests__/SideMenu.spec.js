import { mount } from '@vue/test-utils'
import SideMenu from '../SideMenu'

describe('SideMenu', () => {
  const createWrapper = (show, slotContent) => {
    return mount(SideMenu, {
      propsData: {
        show,
      },
      slots: {
        default: slotContent,
      },
    })
  }

  it('show=trueの時、メニュー内容を表示すること', () => {
    const expectedContent = 'テスト'
    const wrapper = createWrapper(true, expectedContent)

    expect(wrapper.text()).toBe(expectedContent)
  })

  it('show=trueの時、メニュー内容を表示すること', () => {
    const content = 'テスト'
    const wrapper = createWrapper(false, content)

    expect(wrapper.text()).not.toBe(content)
  })
})
