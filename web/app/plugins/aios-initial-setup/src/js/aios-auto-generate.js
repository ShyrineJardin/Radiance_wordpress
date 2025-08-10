// import saveChanges from './functions/saveChanges'
import Open from './aios-auto-generate/functions/_open';
import Close from './aios-auto-generate/functions/_close';
import Selector from './aios-auto-generate/functions/_selector';
import SelectTemplate from './aios-auto-generate/functions/_selectTemplate';
import RevokeTemplate from "./aios-auto-generate/functions/_revokeTemplate";
import Prerequisite from "./aios-auto-generate/functions/_prerequisite";

(function () {
	jQuery(document).ready(function () {
		// Run functions
		// saveChanges()
		Open();
		Close();
		Selector();
		SelectTemplate();
		RevokeTemplate();
		Prerequisite();
	})
})(jQuery);
