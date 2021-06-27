import flushPromises from 'flush-promises'
import { catRepositoryKey } from '@/domain/cat/catRepositoryInterface'
import { CatRepositoryStub } from '@/infrastructure/cat/CatRepositoryStub'
import { mount } from '@vue/test-utils'
import CheckBoxList from '@/components/common/checkBox/CheckBoxList'
import Home from '../Home'
import LabeledFormRow from '@/components/common/form/LabeledFormRow'
import LabeledCheckBox from '@/components/common/checkBox/LabeledCheckBox'
import { CatType } from '@/domain/cat/CatType'
import { CatCharacterics } from '@/domain/cat/CatCharacterics'

describe('Home', () => {
  const catRepository = new CatRepositoryStub()

  const createWrapper = () => {
    return mount(Home, {
      stubs: {
        CheckBoxList,
        DefaultLayout: true,
        PageContent: true,
        SectionTitle: true,
        FormRowList: true,
        LabeledFormRow,
        LabeledCheckBox,
        FormRow: true,
        SimpleButton: true,
      },
      provide: {
        [catRepositoryKey]: catRepository,
      },
    })
  }

  it('ロード後にチェックボックス一覧が表示されること', async () => {
    catRepository.typeList = [
      new CatType('type-1', 'type1'),
      new CatType('type-2', 'type2'),
    ]
    catRepository.charactericsList = [
      new CatCharacterics('character-1', 'character1'),
      new CatCharacterics('character-2', 'character2'),
      new CatCharacterics('character-3', 'character3'),
    ]

    const wrapper = createWrapper()
    await flushPromises()

    expect(wrapper.findAllComponents(LabeledCheckBox).length).toBe(5)
  })
})
