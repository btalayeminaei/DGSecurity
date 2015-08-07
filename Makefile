UNIT_TEST_DIR=unittests
.PHONY: test

test: autoload.php $(UNIT_TEST_DIR)
	phpunit --bootstrap $< $(UNIT_TEST_DIR)
