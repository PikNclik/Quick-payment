import 'package:animate_do/animate_do.dart';
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/extensions/assets_extension.dart';
import 'package:tahsaldar/ui/core/layouts/base_scroll_view.dart';
import 'package:tahsaldar/ui/widgets/animations/animated_column.dart';

import '../../resources/text_styles/text_styles.dart';
import '../../widgets/buttons/customized_button.dart';

enum AnimationType { roulette, fadeInRight, fadeInUpRight, none }

class AuthFrame extends StatelessWidget {
  final String? image;
  final AnimationType? animationType;
  final Widget widget;
  final String? title;
  final String? body;
  final String actionText;
  final Function() action;
  final MutableLiveData<bool> enabled;
  const AuthFrame({
    this.image,
    this.animationType = AnimationType.none,
    required this.widget,
    this.title,
    this.body,
    required this.actionText,
    required this.action,
    required this.enabled,
    Key? key,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return LiveDataBuilder<bool>(
      data: enabled,
      builder: (context, enabled) {
        return BaseScrollView(
          child: Padding(
            padding: const EdgeInsets.symmetric(horizontal: 15),
            child: AnimatedColumn(
              mainAxisAlignment: MainAxisAlignment.spaceAround,
              children: [
                const SizedBox(height: 40),
                SizedBox(
                  height: 280,
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    mainAxisSize: MainAxisSize.max,
                    children: [
                      if (image != null && animationType == AnimationType.roulette) Roulette(child: Image.asset(image!.pngAsset)),
                      if (image != null && animationType == AnimationType.fadeInRight) FadeInRight(child: Image.asset(image!.pngAsset)),
                      if (image != null && animationType == AnimationType.fadeInUpRight) FadeInUp(child: FadeInRight(child: Image.asset(image!.pngAsset))),
                    ],
                  ),
                ),
                const SizedBox(height: 24),
                Row(
                  mainAxisAlignment: MainAxisAlignment.start,
                  crossAxisAlignment: CrossAxisAlignment.center,
                  children: [
                    Flexible(
                      child: AnimatedColumn(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        //mainAxisAlignment: MainAxisAlignment.start,
                        children: [
                          if (title != null) Text(title!, style: title1),
                          const SizedBox(height: 1),
                          if (body != null) Text(body!, style: body2),
                        ],
                      ),
                    ),
                  ],
                ),
                widget,
                Column(
                  children: [
                    const SizedBox(height: 32),
                    CustomizedButton(
                      enabled: enabled,
                      text: actionText,
                      callback: action,
                      width: 110,
                    ),
                    const SizedBox(height: 42),
                  ],
                ),
              ],
            ),
          ),
        );
      },
    );
  }
}

///ANIMATIONS EXAMPLES ///
/*
*
SizedBox(
                height: 500,
                child: Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      FadeInRightBig(
                        child: Image.asset(
                          'login'.pngAsset,
                          height: 100,
                        ),
                      ),
                      const SizedBox(height: 30),
                      FadeInRight(
                        child: Image.asset('login'.pngAsset, height: 100),
                      ),
                      const SizedBox(height: 30),
                      Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        crossAxisAlignment: CrossAxisAlignment.center,
                        children: [
                          FadeInUpBig(
                            child: Image.asset(
                              'login'.pngAsset,
                              height: 100,
                            ),
                          ),
                          const SizedBox(width: 30),
                          FadeInUp(
                            child: Image.asset(
                              'login'.pngAsset,
                              height: 100,
                            ),
                          )
                        ],
                      ),
                    ],
                  ),
                ),
              ),
* */
