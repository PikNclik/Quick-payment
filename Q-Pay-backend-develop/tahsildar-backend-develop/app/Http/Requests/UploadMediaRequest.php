<?php

namespace App\Http\Requests;

class UploadMediaRequest extends MainRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $full_rules['files'] = 'required';
        $full_rules['files.*'] = ['mimes:jpg,jpeg,png,mp4,pdf,svg,ppt,pptx,xlx,xlsx,docx,doc,DWG,dwg'];

        switch (request()->path) {

            case 'table_of_quantity':
            case 'offer':
                $full_rules['files.*'] =
                    'mimes:jpg,jpeg,png,mp4,pdf,svg,ppt,pptx,xlx,xlsx,docx,doc,DWG,dwg|max:' . (10240 * 1.5);
                break;

            default:
                return $full_rules;
        }
        
        return $full_rules;
    }
}
