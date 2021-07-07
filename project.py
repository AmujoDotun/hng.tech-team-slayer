import os
from flask import Flask, render_template, request, url_for, redirect, send_from_directory
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from db_setup import Base, filesPaths
from flask_uploads import UploadSet, configure_uploads
from werkzeug.utils import secure_filename

engine = create_engine('postgres://emeka:postgresemeka@localhost/imagedb')
Base.metadata.bind = engine

DBSession = sessionmaker(bind = engine)
session = DBSession()

app = Flask(__name__)
linkToCdir =  os.path.dirname(os.path.abspath(__file__))
pathToFiles = os.path.dirname(os.path.join(linkToCdir, 'static/files/'))
UPLOAD_FOLDER = pathToFiles
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER
ALLOWED_EXTENSIONS = set(['pdf', 'png', 'jpg','doc','jpeg'])
uploadFolder = app.config['UPLOAD_FOLDER']

def valid_ext(filename):
    return '.' in filename and filename.rsplit('.',1)[1].lower() in ALLOWED_EXTENSIONS

#route to select and store file in folder
@app.route('/storefile', methods=['POST','GET'])
def storefile():
    if request.method == 'POST':
        file = request.files['name']#getting the actual file
        if  file and 'name' in request.files:
            if valid_ext(file.filename):#getting the file name and using testing the validity of its extension
                filename = secure_filename(file.filename)
                file.save(os.path.join(uploadFolder,filename))
                return redirect(url_for('storepath', filename = filename ))
    else:
        return render_template('selectfile.html')

#route to store file path in db
@app.route('/storepath/<filename>')
def storepath(filename):
    filePath = os.path.join(uploadFolder,filename)
    newPath = filesPaths(path = filePath)
    session.rollback()
    session.add(newPath)
    session.commit()
    return redirect(url_for('viewfiles'))


#route to view all file path in data base (not really needed)
@app.route('/viewpaths')
def viewpaths():
    DBSession = sessionmaker(bind = engine)
    session = DBSession()
    allStoredPaths = session.query(filesPaths).all()
    return render_template('storedpaths.html', allStoredPaths = allStoredPaths)

#route to view all file in folder
@app.route('/viewfiles')
def viewfiles():
    filesdir = os.listdir(uploadFolder)
    return render_template('storedfiles.html', filesdir = filesdir)

#route to download file
@app.route('/download/<file>')
def download(file):
    return send_from_directory(uploadFolder, file, as_attachment= True)
    
    


if __name__ == '__main__':
    app.run(debug=True)