<?php
class UploadPresenter extends InitPresenter
{
    public function __init__() {
        parent::__init__();
    }

    public function __main__() {

        $this->upLoadPhoto();

        $this->fileBrowse();
    }
}
?>
