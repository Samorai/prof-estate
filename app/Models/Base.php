<?php
namespace App\Models;

use Jenssegers\Mongodb\Model as Eloquent;

/**
 * Class Base
 * @package App\Models
 */
abstract class Base extends Eloquent
{
    const PRIMARY_KEY = '_id';
    protected $connection = 'mongodb';
    protected $validation_rules = [];

    public function getId()
    {
        return (string)$this->{self::PRIMARY_KEY};
    }

    /**
     * @param array $options
     * @return $this
     */
    public function save(array $options = [])
    {
        $this->validate($this->getDirty());

        return parent::save($options) ? $this : false;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            $this->setAttribute($attribute, $value);
        }

        return $this;
    }

    public static function findById($id)
    {
        return self::where(self::PRIMARY_KEY, '=', $id)->firstOrFail();
    }

    /**
     * @param array $values
     * @param array $validation_rules
     * @throw ValidationException
     * @return $this
     */
    protected function validate(array $values, $validation_rules = [])
    {
        return $this;
    }
}