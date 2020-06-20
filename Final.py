
# -*- coding: utf-8 -*-
"""
Created on Sat Jun 20 20:41:35 2020

@author: Admin
"""

import pandas as pd 
import numpy as np 
from ast import literal_eval
from sklearn.preprocessing import LabelEncoder
import matplotlib.pyplot as plt
import pickle

from ast import literal_eval


dframe = pd.read_excel("test12.xlsx")

id_title = dframe.copy()
id_title = id_title.drop(['Title', 'Genre', 'Rating', 'Incentive', 'Views'], axis = 1)
id_title = int(id_title.iloc[:, 0].values)
dframe = dframe.drop(['Id', 'Title'], axis=1)

dframe['Genre'] = dframe['Genre'].apply(literal_eval)

def get_list(x):
    if isinstance(x, list):
        names = [i['name'] for i in x]
        #Check if more than 3 elements exist. If yes, return only first three. If no, return entire list.
        if len(names) > 3:
            names = names[:3]
        return names

    #Return empty list in case of missing/malformed data
    return []

#movies_final['genres'] = movies_final['genres'].apply(get_list)

def clean_data(x):
    if isinstance(x, list):
        return [str.lower(i.replace(" ", "")) for i in x]
    else:
        #Check if director exists. If not, return empty string
        if isinstance(x, str):
            return str.lower(x.replace(" ", ""))
        else:
            return ''
        
#movies_final['genres'] = movies_final['genres'].apply(clean_data)

dframe['Genre'] = dframe['Genre'].apply(get_list)
dframe['Genre'] = dframe['Genre'].apply(clean_data)


movie0 = dframe.iloc[:, :].values

filename = 'finalized_model_hack.sav'
loaded_model = pickle.load(open(filename, 'rb'))

filename = 'finalized_le_hack.sav'
le_model = pickle.load(open(filename, 'rb'))


for i in range(0, movie0.shape[0]):
    movie0[i , 0] = str(movie0[i , 0])
    
movie0[:, 0] = le_model.transform(movie0[:, 0])

y_pred_movie0 = loaded_model.predict(movie0)
y_pred_movie0 = int(np.ceil(y_pred_movie0))

print(y_pred_movie0)


import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="hackDb"
)

mycursor = mydb.cursor()

sql = "UPDATE videodata SET VideoPoints ="+ str(y_pred_movie0) + " WHERE ID = " + str(id_title);

mycursor.execute(sql)

mydb.commit()

print(mycursor.rowcount, "record(s) affected")
