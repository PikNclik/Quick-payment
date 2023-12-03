import { ngSelectBankConfig } from "src/app/models/data/bank.model";
import { ngSelectCityConfig } from "src/app/models/data/city.model";
import { ngSelectMerchantConfig } from "src/app/models/data/merchant.model";
import { transactionStatus } from "src/app/models/data/transaction.model";
import { FilterInputType, FilterSchema, FilterSelectOption } from "src/app/shared/components/cms/filters/config/filter.iterface";

export let transactionsFilterSchema: FilterSchema = {
  query: true,
  inputs: [
    {
      key: 'status',
      label: 'status',
      inputType: FilterInputType.select,
      options: [...transactionStatus.entries()].map(e => new FilterSelectOption({ value: e[0], label: e[1] })),
    },
    {
      key: 'from_date',
      label: 'from_date',
      inputType: FilterInputType.date,
    },
    {
      key: 'to_date',
      label: 'to_date',
      inputType: FilterInputType.date,
    },
    {
      key: 'user_id',
      label: 'merchant',
      inputType: FilterInputType.ng_select,
      ngSelectConfig: ngSelectMerchantConfig,
    },
    {
      key: 'bank_id',
      label: 'bank',
      inputType: FilterInputType.ng_select,
      ngSelectConfig: ngSelectBankConfig,
    },
    {
      key: 'city_id',
      label: 'city',
      inputType: FilterInputType.ng_select,
      ngSelectConfig: ngSelectCityConfig,
    },
  ],
}
