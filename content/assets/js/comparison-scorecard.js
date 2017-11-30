function resizeRows(scorecard)
{
	for(var rowType in scorecard.master) {
		var masterRows = scorecard.master[rowType],
			learnerRows = scorecard.learner[rowType];

		masterRows.each(function(index, value) {
			index = index + 1;

			var row = $(this),
				learnerRow = $("#learner_" + rowType + "_row_" + index),
				height = row.height();

			setHeight(height, learnerRow);
		});
	}
}

function getRows()
{
	return resizeRows({
		master: {
			test: $("[id*=master_test_row]"),
			overall: $("[id*=master_overall_row]")
		},
		learner: {
			test: $("[id*=learner_test_row]"),
			overall: $("[id*=learner_overall_row]")
		}
	});
}

function resizeGlobalComment()
{
	var master = $("#master_global_comment"),
		learner = $("#learner_global_comment");

	setHeight(master.height(), learner);
}

function setHeight(master, learner)
{
	if(master != learner.height()) {
		learner.height(master);
	}
}

function init()
{
	getRows();
	resizeGlobalComment();
}

$(document).ready(function() {

	init();

	$(window).on('resize', init);
});
