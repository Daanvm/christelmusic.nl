.PHONY: update-composer
update-composer:
	docker-compose run composer-build composer update --ignore-platform-req=ext-imagick

.PHONY: make-new-jewelcase-image
make-new-jewelcase-image:
	docker-compose run christelmusic-nl-php php ./scripts/generate_jewelcase_img.php