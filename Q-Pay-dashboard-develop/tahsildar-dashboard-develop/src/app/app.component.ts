import { Component } from '@angular/core';
import { NavigationEnd, Router } from '@angular/router';
import { filter, take } from 'rxjs';
import { PageTitleService } from './shared/services/page.title.service';
import { ThemeService } from './shared/services/theme.service';
import { TranslationService } from './shared/services/translation.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss'],
})
export class AppComponent {
  constructor(
    public readonly themeService: ThemeService,
    readonly pageTitleService: PageTitleService,
    public readonly translationService: TranslationService,
  ) {}
}
