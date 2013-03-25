const SLICE_DIMENSION = 300;
const QUALITY = 8;

app.preferences.rulerUnits = Units.PIXELS;
app.preferences.typeUnits = TypeUnits.PIXELS;
app.displayDialogs = DialogModes.NO;

if (app.documents.length > 0)
{
    var folder = Folder.selectDialog("选择输出文件夹");
	if (folder)
	{
		var docWidth = app.activeDocument.width;
		var docHeight = app.activeDocument.height;

		for (var i = 0; i < docWidth; i += SLICE_DIMENSION)
		{
			for (var j = 0; j < docHeight; j += SLICE_DIMENSION)
			{
				var region = [ [ i, j ],
								[ i + SLICE_DIMENSION, j ],
								[ i + SLICE_DIMENSION, j + SLICE_DIMENSION ],
								[ i, j + SLICE_DIMENSION ],
								[ i, j ] ];
				app.activeDocument.selection.select(region);
				app.activeDocument.selection.copy();
				
				var newDocWidth = Math.min(SLICE_DIMENSION, docWidth - i);
				var newDocHeight = Math.min(SLICE_DIMENSION, docHeight - j);
				
				app.documents.add (newDocWidth, newDocHeight);
				app.activeDocument.paste();
				var jpegOptions = new JPEGSaveOptions();
				jpegOptions.quality = QUALITY;
				app.activeDocument.saveAs(new File(folder + "/" + (i / 300) + "_" + (j / 300) + ".jpg"), jpegOptions);
				app.activeDocument.close(SaveOptions.DONOTSAVECHANGES);
			}
		}    
	}
}