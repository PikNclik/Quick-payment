import 'package:freezed_annotation/freezed_annotation.dart';

part 'total_amount.freezed.dart';
part 'total_amount.g.dart';

// ----------(json)----------
/*
 {
        "total_amount": 100000,
        "last_record": "2022-02-16 16:33:29"
    }
*/
// --------------------------

@freezed
class TotalAmount with _$TotalAmount {
  const factory TotalAmount({
    dynamic totalAmount,
    String? lastRecord,
  }) = _TotalAmount;

  factory TotalAmount.fromJson(Map<String, dynamic> json) => _$TotalAmountFromJson(json);
}
