import 'package:easy_localization/easy_localization.dart'as d ;
import 'package:flutter/material.dart';

import '../../../resources/text_styles/text_styles.dart';

class AboutUs extends StatelessWidget {
  const AboutUs({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InkWell(
      child: Text(
        'about_Q_pay'.tr(),
        style: body3,
      ),
        onTap: () {
          showDialog(
              context: context,
              builder: (context) => Dialog(
                alignment: Alignment.center,
                elevation: 5,
                child: SingleChildScrollView(
                  child: Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 20.0),
                    child: Column(children: [
                      const SizedBox(height: 20),
                      Directionality(
                        textDirection: TextDirection.rtl,
                        child: Text("about_Q-pay".tr(),style: body1,
                          textAlign: TextAlign.center,
                        ),
                      ),
                      const SizedBox(height: 20),
                    ]),
                  ),
                ),
              ));
        }
    );
  }
}
