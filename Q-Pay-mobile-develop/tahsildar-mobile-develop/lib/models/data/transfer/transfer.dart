/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:freezed_annotation/freezed_annotation.dart';
part 'transfer.freezed.dart';
part 'transfer.g.dart';




@freezed
class Transfer with _$Transfer {
  const factory Transfer({
    String? bankId,
    String? phone,
    int? amount,
    String? bankAccountNumber,
    String? name,

  }) = _Transfer;

  factory Transfer.fromJson(Map<String, dynamic> json) => _$TransferFromJson(json);
}
