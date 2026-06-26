		<?= $mostrarLoader ?? '' ?>
		<?= App\Scripts::isEmpty() ? $script ?? '' : App\Scripts::toHtml() ?>
	</body>
</html>
