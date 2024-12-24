import {
  FilterInputType,
  FilterSchema,
  FilterSelectOption
} from "src/app/shared/components/cms/filters/config/filter.iterface";
import {ngSelectFromToBankConfig} from "../../../../../models/data/bank.model";
import {transactionStatus, transactionType} from "../../../../../models/data/transaction.model";

export let transactionToDoFilter: FilterSchema = {
  inputs: [
    {
      key: 'from_bank_id',
      label: 'from_bank',
      inputType: FilterInputType.ng_select,
      ngSelectConfig: () => ngSelectFromToBankConfig({
        placeHolder: "from_bank"
      }),
    },
    {
      key: 'to_bank_id',
      label: 'to_bank',
      inputType: FilterInputType.ng_select,
      ngSelectConfig: () => ngSelectFromToBankConfig({
        placeHolder: "to_bank"
      }),
    },
    {
      key: 'executed',
      label: 'status',
      inputType: FilterInputType.select,
      options:[...(new Map([[1, 'Executed'], [0, 'Not Executed'],])).entries()]
        .map(e => new FilterSelectOption({ value: e[0], label: e[1] }))
    },
    {
      key: 'due_date',
      label: 'due_date',
      inputType: FilterInputType.date,
    },
  ],
}
