import {FilterInputType, FilterSchema, FilterSelectOption} from "src/app/shared/components/cms/filters/config/filter.iterface";
import {ngSelectFromToBankConfig} from "../../../../../models/data/bank.model";

export let merchantsFilter: FilterSchema = {
  query: true,
  inputs: [
    {
      key: 'created_at_from',
      label: 'created_at_from',
      inputType: FilterInputType.date,
    },
    {
      key: 'created_at_to',
      label: 'created_at_to',
      inputType: FilterInputType.date,
    },
    {
      key: 'activated_at_from',
      label: 'activated_at_from',
      inputType: FilterInputType.date,
    },
    {
      key: 'activated_at_to',
      label: 'activated_at_to',
      inputType: FilterInputType.date,
    },
    {
      key: 'completed',
      label: 'completed',
      inputType: FilterInputType.select,
      options: [ new FilterSelectOption({ value: 0, label: 'No' }),new FilterSelectOption({ value: 1, label: 'Yes' })]
    },
  ],
}
