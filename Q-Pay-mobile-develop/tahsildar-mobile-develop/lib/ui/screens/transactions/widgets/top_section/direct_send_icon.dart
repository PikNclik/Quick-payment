import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/screens/transactions/viewmodels/transactions_viewmodel.dart';
import 'package:tahsaldar/ui/widgets/clickable_svg/clickable_svg.dart';
import 'package:tahsaldar/ui/widgets/instance/instance_builder.dart';

class DirectSend extends StatelessWidget {
  const DirectSend({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<TransactionsViewModel>(
      builder: (viewModel) => ClickableSvg(
          svg: 'direct-send', callback: viewModel.downloadExcelFile),
    );
  }
}
