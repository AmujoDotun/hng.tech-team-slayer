import sys
from sqlalchemy import Column, ForeignKey, Integer, String
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy import create_engine
from flask_sqlalchemy import SQLAlchemy

Base = declarative_base()

class filesPaths(Base):
    __tablename__ = 'files_paths'

    id = Column(Integer, primary_key=True)
    path = Column(String(300))

engine = create_engine('postgres://emeka:postgresemeka@localhost/imagedb')
Base.metadata.create_all(engine)
