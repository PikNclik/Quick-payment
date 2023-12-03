import { Pipe, PipeTransform } from '@angular/core';

@Pipe({ name: 'PropertyKey', standalone: true })
export class BaseCmsPropertyKeyPipe implements PipeTransform {
  transform(e: any, propKey?: any) {
    let prop = e;
    if (propKey && e && e != null) {
      if (propKey.includes('.')) {
        const array = propKey.split('.');
        for (let i = 0; i < array.length; i++) {
          if (prop == null) return "";
            prop = prop[array[i]];
        }
        return prop;
      }
      return e[propKey];
    }
    return e;
  }
}
