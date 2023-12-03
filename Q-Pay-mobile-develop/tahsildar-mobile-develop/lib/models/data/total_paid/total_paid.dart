import 'package:freezed_annotation/freezed_annotation.dart';
import '../../data_models.dart';
part 'total_paid.freezed.dart';
part 'total_paid.g.dart';

// ----------(json)----------
/*
 {
        "total_amount": 100000,
        "last_record": "2022-02-16 16:33:29"
    }
*/
// --------------------------

@freezed
class TotalPaid with _$TotalPaid {
  const factory TotalPaid({
    TotalAmount? paid,
    TotalAmount? pending,
  }) = _TotalPaid;

  factory TotalPaid.fromJson(Map<String, dynamic> json) => _$TotalPaidFromJson(json);
}
