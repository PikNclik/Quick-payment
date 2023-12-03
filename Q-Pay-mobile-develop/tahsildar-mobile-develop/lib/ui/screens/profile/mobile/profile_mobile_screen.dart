import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/models/data_models.dart';
import 'package:tahsaldar/ui/core/layouts/theme_widget.dart';
import 'package:tahsaldar/ui/screens/profile/widgets/profile_top_section.dart';
import 'package:tahsaldar/ui/shared/total_amount/total_amount_card.dart';
import 'package:tahsaldar/ui/widgets/animations/animated_column.dart';
import "package:tahsaldar/ui/widgets/instance/instance_builder.dart";
import '../../../core/layouts/base_layout.dart';
import "../viewmodels/profile_viewmodel.dart";
import '../widgets/profile_menu.dart';

class ProfileMobileScreen extends StatelessWidget {
  const ProfileMobileScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<ProfileViewModel>(
      builder: (viewModel) {
        return ThemeWidget(
          builder: (context, theme) {
            return BaseLayout(
              top: 20,
              child: AnimatedColumn(
                mainAxisAlignment: MainAxisAlignment.start,
                children: [
                  const ProfileTopSection(),
                  const SizedBox(height: 12),
                  LiveDataBuilder<TotalPaid>(
                    data: viewModel.params.totalPaid,
                    builder: (context, totalPaid) => TotalAmountCard(
                      month: viewModel.params.month,
                      year: viewModel.params.year,
                      totalPaid: totalPaid,
                      filter: viewModel.getTotalPaid,
                    ),
                  ),
                  const SizedBox(height: 15),
                  const ProfileMenu(),
                ],
              ),
            );
          },
        );
      },
    );
  }
}
