<?php

namespace calderawp\object;

/**
 * Class almostStd
 *
 *
 * @package calderawp\object
 */
abstract class almostStd implements \JsonSerializable {

	/**
	 * almostStd constructor.
	 *
	 * @param \stdClass|null $obj Optional. stdClass object to set properties from
	 */
	public function __construct( \stdClass $obj = null )
	{
		if( null !== $obj ){
			$this->translate( $obj );
		}

	}

	/**
	 * Allow use of named getters
	 *
	 * @param string $name Function name, should be get_$prop()
	 * @param $arguments NOT USED
	 *
	 * @return mixed
	 */
	public function __call( $name, $arguments ) {
		$prop = str_replace( 'get_', '', $name );
		if( property_exists( $this->$prop, $this ) ){
			return $this->$prop;
		}

	}


	/**
	 * Set value of property if it exists
	 * 
	 * @param string $prop Name of property
	 * @param mixed $value Value of property
	 */
	public function __set( $prop, $value )
	{
		if( property_exists( $this->$prop, $this ) ){
			$this->$prop = $value;
		}

	}

	/**
	 * Get value of property if it exists
	 *
	 * @param string $prop Name of property
	 *
	 * @return mixed
	 */
	public function __get( $prop )
	{
		if( property_exists(  $this, $prop ) ){
			return $this->$prop;
		}

	}


	/**
	 * Translate from a stdClass object to this object type
	 *
	 * @param \stdClass $obj
	 */
	public function setFromObject( \stdClass $obj )
	{
		$this->translate( $obj );
	}

	/**
	 * @inheritdoc
	 */
	public function jsonSerialize()
	{
		return $this->toArray();
	}

	/**
	 * Convert to array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$vars = get_object_vars(  $this );
		$array = [];
		foreach( $vars as $property => $value ){
			$array[ $property ] = $value;
		}

		return $array;
	}

	/**
	 * @param \stdClass $obj
	 */
	protected function translate( \stdClass $obj )
	{
		foreach ( $obj as $property => $value ) {
			if(  property_exists( $property, $this ) ){
				$this->$property = $value;
			}

		}
	}

}
