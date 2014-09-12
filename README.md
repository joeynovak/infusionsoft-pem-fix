infusionsoft-pem-fix
====================

This script will look for any infusionsoft.pem file with the old equifax ca recursively in the specified path, and update it with Infusionsoft's new pem file.  It will tell you about any file called infusionsoft.pem with Infusionsoft's old pem file, but it only updates files that match the md5 of the original file.

To use it, just change the path at the beginning of the script to be the root of your web directory.

If anyone finds any issues, please submit a pull request, and we'll get it merged in asap.