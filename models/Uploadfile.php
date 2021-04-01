<?php


namespace app\models;


use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use ZipArchive;

class Uploadfile extends Model
{
    /**
     * @var Uploadedfile
     */
    public $file;
    public $arr = [];
    public $res;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'zip'],
        ];
    }

    public function upload()
    {

        if ($this->validate()) {
            $this->file->saveAs('uploads/' . $this->file->baseName . '.' . $this->file->extension);
            $temp = true;
            while ($temp) {
                $this->arr = array_diff(scandir('uploads/'), ['.', '..']);
                foreach ($this->arr as $value) {
                    $filename = explode('.', $value);
                    if ($filename['1'] == 'zip') {
                        $this->unpack($value);
                    } else {
                        $temp = false;
                    }
                }
            }
            if(file_exists('uploads/card.xml')) {
                unlink('uploads/card.xml');
            }
            if(file_exists('uploads/meta.xml')) {
                unlink('uploads/meta.xml');
            }
            return $this->res = 'Файл загружен';
        } else {
            return false;
        }
    }

    public function unpack($link)
    {
        $zip = new ZipArchive();
        $zip->open('uploads/' . $link);
        $zip->extractTo('uploads/');
        $zip->close();
        unlink('uploads/' . $link);
    }

}