import { Component, EventEmitter, Input, Output } from '@angular/core';
import { SharedModule } from '../../../modules/shared.module';
import { DndDirective } from './directives/dnd.directive';
import { MatIconModule } from '@angular/material/icon';
import { MatSnackBar, MatSnackBarModule } from '@angular/material/snack-bar';

@Component({
  selector: 'app-file-drag-drop',
  templateUrl: './file-drag-drop.component.html',
  styleUrls: ['./file-drag-drop.component.scss'],
  standalone: true,
  imports: [
    SharedModule,
    MatIconModule,
    MatSnackBarModule,
  ],
  providers: [
    DndDirective,
  ]
})
export class FileDragDropComponent {
  /**
   * @param {string} mime accepted dragged files
   */
  @Input() set mime(value: string | undefined) {
    if (value) this.mimeType = value;
  }

  /**
   * @param {EventEmitter<any | undefined>} onFile emit files when dragged or browsed
   */
  @Output() onFileSelected: EventEmitter<any | undefined> = new EventEmitter();

  /**
   * @param {string} imageSrc image path if exist to preview
   */
  @Input() imageSrc?: string | ArrayBuffer | null;

  public files: any[] = [];
  
  /**
   * @param {string} mimeType accepted dragged files
   */
  public mimeType: string = "image";

  /**
   * @param {string} fileName selected file name
   */
  public fileName: string = '';

  constructor(private snackBar: MatSnackBar) {}

  /**
  * on file drop handler
  */
  onFileDropped($event: any) {
    this.prepareFilesList($event);
  }

  /**
   * handle file from browsing
   */
  fileBrowseHandler(event: any) {
    const files = Object.values(event.target.files);
    if (Array.isArray(files) && files.length > 0) {
      this.prepareFilesList(files);
    }
  }

  /**
     * Convert Files list to normal array list
     * @param files (Files List)
     */
  prepareFilesList(files: Array<any>) {
    for (const item of files) {
      if (item.type.includes(this.mimeType) || this.mimeType == "*") {
        this.files.push(item);
        if (item.name) this.fileName = item.name;
      } else {
        this.snackBar.open('File type is not valid')
      }
    }
    if (this.files.length > 0) {
      this.onFileSelected.emit(this.files[0]);
      this.previewImage()
    }
  }

  private previewImage() {
    if (this.files.length > 0) {
      const file = this.files[0];

      const reader = new FileReader();
      reader.onload = e => this.imageSrc = reader.result;

      reader.readAsDataURL(file);
    }
  }

  public deleteFiles() {
    this.files.length = 0;
    this.imageSrc = undefined;
    this.onFileSelected.emit(null);
  }

  /**
   * format bytes
   * @param bytes (File size in bytes)
   * @param decimals (Decimals point)
   */
  formatBytes(bytes: any, decimals: any) {
    if (bytes === 0) {
      return '0 Bytes';
    }
    const k = 1024;
    const dm = decimals <= 0 ? 0 : decimals || 2;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
  }
}
