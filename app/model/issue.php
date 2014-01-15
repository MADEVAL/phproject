<?php

namespace Model;

class Issue extends Base {

	protected $_table_name = "issue";

	public function hierarchy() {
		$f3 = \Base::instance();
		$db = $f3->get("db.instance");
		return $db->exec(
"SELECT _id AS id, name FROM (
	SELECT @r AS _id, name, (
		SELECT @r := parent_id FROM issue n
		WHERE id = _id
	) FROM (
		SELECT @r := '{$this->id}'
	) vars, issue c
) c
WHERE _id > 1
GROUP BY _id", null, 60);
	}

	public static function clean($string) {
		return preg_replace('/(?:(?:\r\n|\r|\n)\s*){2}/s', "\n\n", str_replace("\r\n", "\n", $string));
	}

}

