import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/controllers/auth_controller.dart';
import 'package:tahsaldar/extensions/assets_extension.dart';
import 'package:tahsaldar/models/data_models.dart';
import 'package:tahsaldar/ui/resources/colors/colors.dart';
import 'package:tahsaldar/ui/screens/transactions/viewmodels/transactions_viewmodel.dart';
import 'package:tahsaldar/ui/widgets/instance/instance_builder.dart';
import '../../../../../router/app_router.dart';
import '../../../../resources/text_styles/text_styles.dart';
import '../../../../shared/total_amount/total_amount_card.dart';
import '../../../../widgets/clickable_svg/clickable_svg.dart';
import '../../../../widgets/social_media_icon/social_media_icon.dart';
import 'direct_send_icon.dart';

class TopSection extends StatelessWidget {
  const TopSection({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<TransactionsViewModel>(
      builder: (viewModel) {
        return Container(
          decoration: const BoxDecoration(
            color: DesignColors.purple3,
            borderRadius: BorderRadius.only(
              bottomRight: Radius.circular(10),
              bottomLeft: Radius.circular(10),
            ),
          ),
          child: Stack(
            children: [
              Row(
                mainAxisAlignment: MainAxisAlignment.end,
                children: [
                  Image.asset('finger-print'.pngAsset),
                ],
              ),
              Padding(
                padding: const EdgeInsets.fromLTRB(16, 16, 16, 0),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        LiveDataBuilder(
                            data: userLiveData,
                            builder: (context, value) => Text(
                                'welcome'.tr(namedArgs: {
                                  'model': userLiveData.value.fullName
                                          ?.split(' ')[0] ??
                                      ''
                                }),
                                style: title2)),
                        Row(
                          children: [

                            ClickableSvg(
                                svg: 'call',
                                callback: () {
                                  showDialog(context: context, builder: (BuildContext context) {
                                    return Dialog(
                                      child: Padding(
                                        padding: const EdgeInsets.all( 16.0),
                                        child: Column(
                                          mainAxisSize: MainAxisSize.min,
                                          children: [
                                            Text("contact_us".tr(),style:title1 ,),
                                            SizedBox(height: 20,),
                                            const Padding(
                                              padding: EdgeInsets.symmetric(horizontal: 22.0),
                                              child: Column(
                                                crossAxisAlignment: CrossAxisAlignment.center,
                                                children: [
                                                  Row (
                                                  //  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                                                    children: [
                                                      SocialMediaIcon(
                                                        svg: 'call',
                                                        number: '011-2224101',
                                                      ),
                                                      SizedBox(width: 32,),
                                                      Text("011-2224101")
                                                    ],
                                                  ),
                                                  SizedBox(height: 10,),
                                                  Row (
                                                 //   mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                                                    children: [
                                                      SocialMediaIcon(
                                                        svg: 'call',
                                                        number: '0943333320',
                                                      ),
                                                      SizedBox(width: 32,),
                                                      Text("0943333320")
                                                    ],
                                                  ),
                                                  SizedBox(height: 10,),
                                                  Row (
                                                //    mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                                                    children: [
                                                      SocialMediaIcon(
                                                        svg: 'email',
                                                        link: 'mailto:support@piknclk.com',
                                                      ),
                                                      SizedBox(width: 32,),
                                                      Text("support@piknclk.com")
                                                    ],
                                                  ),

                                                ],
                                              ),
                                            ),
                                          ],
                                        ),
                                      ),
                                    );
                                  });
                                }),
                            // ClickableSvg(
                            //     icon: Icons.add_card,
                            //     svg: '****',
                            //     callback: () =>
                            //         appRouter.push(const Transfers())),
                            const SizedBox(width: 20),
                            ClickableSvg(
                                svg: 'profile',
                                callback: () =>
                                    appRouter.push(const Profile())),
                            const SizedBox(width: 20),
                            const DirectSend(),
                            const SizedBox(width: 20),
                            ClickableSvg(
                                svg: 'notifications',
                                callback: () =>
                                    appRouter.push(const Notifications())),

                          ],
                        )
                      ],
                    ),
                    const SizedBox(height: 12),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                      Row(
                        children: [
                          Text(
                              "Powered_by".tr(),
                              style: title3),
                          const SizedBox(width: 5,),
                          SvgPicture.asset("pick".svgAsset,height: 30,),
                        ],
                      ),
                // const Spacer(),
                      Flexible(
                        child: Padding(
                          padding: const EdgeInsets.symmetric(horizontal: 4.0),
                          child: Text(
                              "security".tr(),
                              maxLines: 2,
                              textAlign: TextAlign.center,
                              style: title3),
                        ),
                      ),
                    ],),
                    const SizedBox(height: 24),
                    LiveDataBuilder<TotalPaid>(
                      data: viewModel.params.totalPaid,
                      builder: (context, totalPaid) => TotalAmountCard(
                        month: viewModel.params.month,
                        year: viewModel.params.year,
                        totalPaid: totalPaid,
                        filter: viewModel.getTotalPaid,
                      ),
                    ),
                  ],
                ),
              )
            ],
          ),
        );
      },
    );
  }
}
