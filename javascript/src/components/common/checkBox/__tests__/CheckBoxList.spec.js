import { mount } from '@vue/test-utils'
import CheckBoxList from '../CheckBoxList'
import LabeledCheckBox from '../LabeledCheckBox'

describe('CheckBoxList', () => {
  const createWrapper = (items, checked = []) => {
    return mount(CheckBoxList, {
      propsData: {
        items,
        checked,
      },
      stubs: {
        LabeledCheckBox,
      },
    })
  }

  describe('初期状態', () => {
    it('指定された要素が表示されること', () => {
      const items = [
        { id: 'test1', label: 'test1-name' },
        { id: 'test2', label: 'test2-name' },
      ]
      const wrapper = createWrapper(items)
      expect(wrapper.findAllComponents(LabeledCheckBox).length).toBe(2)
      expect(wrapper.text()).toContain('test1-name')
      expect(wrapper.text()).toContain('test2-name')
    })

    it('初期状態でチェック済を指定できること', () => {
      const items = [
        { id: 'test1', label: 'test1-name' },
        { id: 'test2', label: 'test2-name' },
      ]
      const wrapper = createWrapper(items, ['test2'])
      const checkBoxes = wrapper.findAllComponents(LabeledCheckBox)
      expect(checkBoxes.at(0).props()['checked']).toBeFalsy()
      expect(checkBoxes.at(1).props()['checked']).toBeTruthy()
    })
  })

  describe('チェックボックス押下時のイベント', () => {
    test.each([
      [
        '初期状態チェックなし__1つ目をチェック',
        [
          { id: 'item1', label: 'name1' },
          { id: 'item2', label: 'name2' },
        ],
        [],
        0,
        ['item1'],
      ],
      [
        '1つチェック済__別の項目をチェック__新しい項目が追加されること',
        [
          { id: 'item1', label: 'name1' },
          { id: 'item2', label: 'name2' },
        ],
        ['item1'],
        1,
        ['item1', 'item2'],
      ],
      [
        '1つチェック済__同じ項目のチェック解除__空になること',
        [
          { id: 'item1', label: 'name1' },
          { id: 'item2', label: 'name2' },
        ],
        ['item1'],
        0,
        [],
      ],
      [
        '2つチェック済__1つのチェックを解除__1つのチェックが残ること',
        [
          { id: 'item1', label: 'name1' },
          { id: 'item2', label: 'name2' },
        ],
        ['item1', 'item2'],
        0,
        ['item2'],
      ],
    ])('%s', async (title, items, initialChecked, clickItem, expected) => {
      const wrapper = createWrapper(items, initialChecked)
      const checkBoxes = wrapper.findAllComponents(LabeledCheckBox)
      const currentCheckState = checkBoxes
        .at(clickItem)
        .find('input[type="checkbox"]').element.checked
      await checkBoxes
        .at(clickItem)
        .find('input[type="checkbox"]')
        .setChecked(!currentCheckState)

      expect(wrapper.emitted('change')[0][0]).toStrictEqual(expected)
    })
  })
})
