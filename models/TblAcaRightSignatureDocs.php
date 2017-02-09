<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_aca_right_signature_docs".
 *
 * @property integer $doc_id
 * @property string $guid
 * @property string $doc_name
 * @property string $doc_subject
 * @property string $recipient_name
 * @property string $recipient_email
 * @property string $signed_doc_url
 */
class TblAcaRightSignatureDocs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_aca_right_signature_docs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guid', 'doc_name', 'doc_subject', 'recipient_name', 'recipient_email', 'signed_doc_url'], 'required'],
            [['doc_name', 'doc_subject', 'signed_doc_url'], 'string'],
			[['created_date', 'modified_date'], 'safe'],
            [['created_by', 'modified_by','type'], 'integer'],
            [['guid', 'recipient_name'], 'string', 'max' => 100],
            [['recipient_email'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'doc_id' => 'Doc ID',
            'guid' => 'Guid',
            'doc_name' => 'Doc Name',
            'doc_subject' => 'Doc Subject',
            'recipient_name' => 'Recipient Name',
            'recipient_email' => 'Recipient Email',
            'signed_doc_url' => 'Signed Doc Url',
			'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'modified_date' => 'Modified Date',
			'type' => 'Type',
        ];
    }
}
