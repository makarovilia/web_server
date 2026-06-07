<?php

class TagController extends Controller
{
    public function index(): void
    {
        $tagModel = new Tag();
        $fieldModel = new Field();

        $tags = $tagModel->getUnsorted();
        $fields = $fieldModel->all();
        $assignedTags = $tagModel->getAssigned();  

        $this->view('tags/index', [
        'tags' => $tags,
        'fields' => $fields,
        'assignedTags' => $assignedTags
        ]);
    }

    public function attach(): void
    {
        $model = new TagField();

        $model->attach(
            (int)$_POST['tag_id'],
            (int)$_POST['field_id']
        );

        $this->redirect('/course_work/public/');
    }

    public function createField(): void
    {
        if (!empty($_POST['name'])) {
            $field = new Field();
            $field->create(trim($_POST['name']));
        }

        $this->redirect('/course_work/public/');
    }

    public function createTag(): void
    {
    if (!empty($_POST['name'])) {

        $tag = new Tag();

        $tag->create(
            trim($_POST['name'])
        );
    }

    $this->redirect('/course_work/public/');
}
}