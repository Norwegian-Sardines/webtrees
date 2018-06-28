<?php use Fisharebest\Webtrees\GedcomTag; ?>
<?php use Fisharebest\Webtrees\Functions\FunctionsEdit; ?>
<?php use Fisharebest\Webtrees\I18N; ?>

<div class="card mb-4">
	<div class="card-header">
		<a href="#" data-toggle="collapse" data-target="#add-source-citation" aria-expanded="false" aria-controls="add-source-citation">
			<?= I18N::translate('Add a source citation') ?>
		</a>
	</div>

	<div class="card-body collapse" id="add-source-citation">
		<?= FunctionsEdit::addSimpleTag($level . ' SOUR @') ?>

		<?php if ($level === 1): ?>
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9">
					<?php if (strpos($bdm, 'B') !== false): ?>
						<label>
							<input type="checkbox" name="SOUR_INDI" <?= $prefer_level2_sources === '2' ? 'checked' : '' ?> value="1">
							<?= I18N::translate('Individual') ?>
						</label>
						<?php if (preg_match_all('/(' . WT_REGEX_TAG . ')/', $quick_required_facts, $matches)): ?>
							<?php foreach ($matches[1] as $match): ?>
								<?php if (!in_array($match, explode('|', WT_EVENTS_DEAT))): ?>
									<label>
										<input type="checkbox" name="SOUR_<?= $match ?>" <?= $prefer_level2_sources === '1' ? 'checked' : '' ?> value="1">
										<?= GedcomTag::getLabel($match) ?>
									</label>
								<?php endif ?>
							<?php endforeach ?>
						<?php endif ?>
					<?php endif ?>

					<?php if (strpos($bdm, 'D') !== false): ?>
						<?php if (preg_match_all('/(' . WT_REGEX_TAG . ')/', $quick_required_facts, $matches)): ?>
							<?php foreach ($matches[1] as $match): ?>
								<?php if (in_array($match, explode('|', WT_EVENTS_DEAT))): ?>
									<label>
										<input type="checkbox" name="SOUR_<?= $match ?>" <?= $prefer_level2_sources === '1' ? 'checked' : '' ?> value="1">
										<?= GedcomTag::getLabel($match) ?>
									</label>
								<?php endif ?>
							<?php endforeach ?>
						<?php endif ?>
					<?php endif ?>

					<?php if (strpos($bdm, 'M') !== false): ?>
						<label>
							<input type="checkbox" name="SOUR_FAM" <?= $prefer_level2_sources === '2' ? 'checked' : '' ?> value="1">
							<?= I18N::translate('Family') ?>
						</label>
						<?php if (preg_match_all('/(' . WT_REGEX_TAG . ')/', $quick_required_famfacts, $matches)): ?>
							<?php foreach ($matches[1] as $match): ?>
								<label>
									<input type="checkbox" name="SOUR_<?= $match ?>" <?= $prefer_level2_sources === '1' ? 'checked' : '' ?> value="1">
									<?= GedcomTag::getLabel($match) ?>
								</label>
							<?php endforeach ?>
						<?php endif ?>
					<?php endif ?>
				</div>
			</div>
		<?php endif ?>

		<?= FunctionsEdit::addSimpleTag(($level + 1) . ' PAGE') ?>
		<?= FunctionsEdit::addSimpleTag(($level + 1) . ' DATA') ?>
		<?= FunctionsEdit::addSimpleTag(($level + 2) . ' TEXT') ?>

		<?php if ($full_citations): ?>
			<?= FunctionsEdit::addSimpleTag(($level + 2) . ' DATE', '', I18N::translate('Date of entry in original source')) ?>
			<?= FunctionsEdit::addSimpleTag(($level + 1) . ' QUAY') ?>
		<?php endif ?>

		<?= FunctionsEdit::addSimpleTag(($level + 1) . ' OBJE') ?>
		<?= FunctionsEdit::addSimpleTag(($level + 1) . ' SHARED_NOTE') ?>
	</div>
</div>
