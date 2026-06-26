		<?= $mostrarLoader ?>
		<?= $script ?>
		<?= App\Scripts::isEmpty() ? '' : App\Scripts::toHtml() ?>
	</body>
</html>
