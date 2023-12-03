import 'package:flutter/cupertino.dart';
import 'package:flutter_switch/flutter_switch.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';

import '../../resources/colors/colors.dart';
import '../loaders/loader.dart';

class CustomizedSwitch extends StatefulWidget {
  const CustomizedSwitch({required this.switchValue, required this.callback, this.loading, Key? key}) : super(key: key);

  final MutableLiveData<bool> switchValue;
  final MutableLiveData<bool>? loading;
  final Function(bool) callback;
  @override
  State<CustomizedSwitch> createState() => _CustomizedSwitchState();
}

class _CustomizedSwitchState extends State<CustomizedSwitch> {
  @override
  Widget build(BuildContext context) {
    return LiveDataBuilder<bool>(
      data: widget.switchValue,
      builder: (context, switchValue) {
        return Row(
          children: [
            widget.loading != null
                ? Row(
                    children: [
                      LiveDataBuilder<bool>(
                        data: widget.loading!,
                        builder: (_, loading) {
                          return loading
                              ? const Loader(
                                  color: DesignColors.primaryColor,
                                  size: 24.0,
                                )
                              : const SizedBox.shrink();
                        },
                      ),
                      const SizedBox(width: 3.0),
                    ],
                  )
                : const SizedBox.shrink(),
            FlutterSwitch(
              value: !switchValue,
              activeColor: DesignColors.primaryColor,
              height: 20.0,
              width: 42.0,
              padding: 4.0,
              onToggle: widget.callback,
              toggleSize: 14.0,
            ),
          ],
        );
      },
    );
  }
}
