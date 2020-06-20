# -*- coding: utf-8 -*-
"""
Created on Wed Jun 17 00:51:17 2020

@author: Admin
"""

import pandas as pd 
import numpy as np 
from ast import literal_eval
from sklearn.preprocessing import LabelEncoder
import matplotlib.pyplot as plt
import pickle

df1 = pd.read_csv('movies_metadata.csv')

C= df1['vote_average'].mean()

m= 1

movies = df1.copy().loc[df1['vote_count'] >= m]

movies = df1.copy().loc[df1['vote_count'] >= m]

def weighted_rating(x, m=m, C=C):
    v = x['vote_count']
    R = x['vote_average']
    # Calculation based on the IMDB formula
    return (v/(v+m) * R) + (m/(m+v) * C)

movies['score'] = movies.apply(weighted_rating, axis=1)

movies_1 = movies.drop(['original_title','adult', 'belongs_to_collection', 'budget', 'homepage', 'imdb_id', 'overview', 'original_language', 'poster_path', 'production_companies', 'production_countries', 'release_date', 'revenue', 'runtime', 'spoken_languages', 'status', 'tagline', 'video', 'vote_average', 'vote_count'], axis=1)

id_title = movies_1.copy()
id_title = id_title.drop(['genres', 'popularity', 'score'], axis = 1)

movies_final = movies_1.copy()
movies_final = movies_final.drop(['id', 'title'], axis=1)

incentive = np.random.rand(movies_final.shape[0]) * 10
incentive = np.ceil(incentive)
incentive = incentive>=5
incentive = incentive.astype('float64')


users = movies.iloc[:, 23:24].values
users = users + 100

movies_final['incentive'] = incentive
movies_final['users'] = users

from ast import literal_eval

movies_final['genres'] = movies_final['genres'].apply(literal_eval)  

def get_list(x):
    if isinstance(x, list):
        names = [i['name'] for i in x]
        #Check if more than 3 elements exist. If yes, return only first three. If no, return entire list.
        if len(names) > 3:
            names = names[:3]
        return names

    #Return empty list in case of missing/malformed data
    return []

movies_final['genres'] = movies_final['genres'].apply(get_list)

def clean_data(x):
    if isinstance(x, list):
        return [str.lower(i.replace(" ", "")) for i in x]
    else:
        #Check if director exists. If not, return empty string
        if isinstance(x, str):
            return str.lower(x.replace(" ", ""))
        else:
            return ''
        
movies_final['genres'] = movies_final['genres'].apply(clean_data)        
movies_final['score'] = np.ceil(movies_final['score'])

###############################################################
# ML model to initial the new score for a movie
Y = movies_final.iloc[:, 2:3].values
score = movies_final.pop('score')
X = movies_final.iloc[:, 0:4].values


for i in range(0, X.shape[0]):
    X[i , 0] = str(X[i , 0])

le = LabelEncoder()
X[:, 0] = le.fit_transform(X[:, 0])

from sklearn.model_selection import train_test_split
X_train, X_test, Y_train, Y_test = train_test_split(X, Y, test_size = 0.2, random_state = 0)

"""from sklearn.preprocessing import MinMaxScaler
sc_X = MinMaxScaler()
X_train = sc_X.fit_transform(X_train)
X_test = sc_X.fit_transform(X_test)
sc_Y = MinMaxScaler()
Y_train = sc_Y.fit_transform(Y_train)
Y_test = sc_Y.fit_transform(Y_test)"""

Y_train = Y_train.reshape(Y_train.shape[0],)
Y_test = Y_test.reshape(Y_test.shape[0],)


from sklearn.ensemble import RandomForestRegressor
regressor = RandomForestRegressor(n_estimators = 1000, random_state = 0)
regressor.fit(X_train, Y_train)

Y_pred = regressor.predict(X_test)

Y_pred1 = np.ceil(Y_pred)
Y_pred2 = np.floor(Y_pred)

print(Y_test[3533])
print(Y_pred1[3533])
print(Y_pred2[3533])


filename = 'finalized_model.sav'
pickle.dump(regressor, open(filename, 'wb'))

filename = 'finalized_le.sav'
pickle.dump(le, open(filename, 'wb'))

loaded_model = pickle.load(open(filename, 'rb'))
result = loaded_model.predict(X_test)
print(result)

le_model = pickle.load(open(filename, 'rb'))

###############################################################

#Score calculations

Score = movies_final.iloc[:, 2:3].values
Users = movies_final.iloc[:, 4:5].values

score_max = np.amax(Score)
score_max_index = np.where(Score == np.amax(Score))

###############################################################

Total_users = np.amax(Users)
result = np.where(Users == np.amax(Users))

Day_10_score = Score - (np.exp(-Users/Total_users)) + (100/(Users/Total_users)+0.0001) 
from sklearn.preprocessing import MinMaxScaler
sc = MinMaxScaler()
Day_10_score = sc.fit_transform(Day_10_score)*10

score_max = np.amax(Day_10_score)
score_max_index = np.where(Day_10_score == np.amax(Day_10_score))

###############################################################

Users = Users * 10

Total_users = np.amax(Users)
result = np.where(Users == np.amax(Users))

Day_11_score = Day_10_score - (np.exp(-Users/Total_users)) + (100/(Users/Total_users)+0.0001)
sc = MinMaxScaler()
Day_11_score = sc.fit_transform(Day_11_score)*10

score_max = np.amax(Day_11_score)
score_max_index = np.where(Day_11_score == np.amax(Day_11_score))

###############################################################

Users = Users * 100

Total_users = np.amax(Users)
result = np.where(Users == np.amax(Users))

Day_12_score = Day_11_score - (np.exp(-Users/Total_users)) + (100/(Users/Total_users)+0.0001)
sc = MinMaxScaler()
Day_12_score = sc.fit_transform(Day_12_score)*10

score_max = np.amax(Day_12_score)
score_max_index = np.where(Day_12_score == np.amax(Day_12_score))

def Daily_Score(score, users):
    
    
########################################################################

movie_final = movies_final.iloc[:, :].values
print(movie_final[1])

movie_final[1, 0].dtype





from ast import literal_eval

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








dframe = pd.read_excel("Input.xlsx")

#movie0 = dframe.iloc[:, 2:6].values

dframe = dframe.drop(['Id', 'Title'], axis=1)

from ast import literal_eval

dframe['Genre'] = dframe['Genre'].apply(literal_eval)
dframe['Genre'] = dframe['Genre'].apply(get_list)
dframe['Genre'] = dframe['Genre'].apply(clean_data)


movie0 = dframe.iloc[:, :].values

for i in range(0, movie0.shape[0]):
    movie0[i , 0] = str(movie0[i , 0])
    
movie0[:, 0] = le.transform(movie0[:, 0])

movie0[:, 0] = le_model.transform(movie0[:, 0])

y_pred_movie0 = regressor.predict(movie0)
y_pred_movie0 = np.ceil(y_pred_movie0)



