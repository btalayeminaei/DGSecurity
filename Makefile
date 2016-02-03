UNIT_TEST_DIR=unittests
TEMPLATES_COMPILED_DIR=templates_c
.PHONY: test install

test: autoload.php $(UNIT_TEST_DIR)
	phpunit --bootstrap $< $(UNIT_TEST_DIR)

install: settings.php $(TEMPLATES_COMPILED_DIR)

$(TEMPLATES_COMPILED_DIR):
	mkdir "$@"

settings.php:
	$(error Please use $@.sample as a reference to manually create $@)
