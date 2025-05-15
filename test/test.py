import tkinter as tk
import tkinter.font
from tkinter import ttk
import time
import sys
import os
import sqlite3

class setsClass:
    def __init__(self, entry):
        self.idshow = entry[0]
        self.idset = entry[1]
        self.position = entry[2]
        self.song = entry[3]

selShow = 14

setItems = []
setTitles = []
maxset = 0
maxsong = [0] * 20
songID = []
songName = []
tableElements = []


editSets = tk.Tk()
editSets.title('Showname')
editSets.config(bg="#aaaaaa")
# main.geometry("800x600+200+200")
editSets.resizable(False, False)

con = sqlite3.connect('Centerstage.sqlite3')
cur = con.cursor()
for row in cur.execute('SELECT * FROM sets WHERE idshow=' + str(selShow) + ' ORDER BY idset ASC, position ASC'):
    newItem = setsClass(row)
    setItems.append(newItem)
    if newItem.idset > maxset:
        maxset = newItem.idset
    if newItem.position > maxsong[newItem.idset]:
        maxsong[newItem.idset] = newItem.position
for row in cur.execute('SELECT * FROM show WHERE idshow=' + str(selShow)):
    showNameString = row[1]
for row in cur.execute('SELECT * FROM song ORDER by name'):
    songID.append(row[0])
    songName.append(row[1])
con.close()

TitleFont = tk.font.Font(family='Helvetica', size=21, weight='bold')
ButtonFont = tk.font.Font(family='Helvetica', size=15, weight='bold')
ListFont = tk.font.Font(family='Helvetica', size=12)

Title = tk.Label(editSets, text='Edit Sets', fg='#ffff00', bg='#aaaaaa', font=TitleFont, padx=10, pady=10)
Title.grid(row=0, column=0, sticky='ew', columnspan=60)
blankLabel1 = tk.Label(editSets, text='', bg='#aaaaaa')
blankLabel1.grid(row=1, column=0, sticky='ew', columnspan=60)
showLabel1 = tk.Label(editSets, text='Showname:', fg='#00ff00', bg='#aaaaaa', font=ButtonFont)
showLabel1.grid(row=2, column=0, sticky='ew', columnspan=60)
showName = tk.Label(editSets, text=showNameString, fg='#ff0000', bg='#aaaaaa', font=ButtonFont)
showName.grid(row=3, column=0, sticky='ew', columnspan=60)
blankLabel2 = tk.Label(editSets, text='', bg='#aaaaaa')
blankLabel2.grid(row=4, column=0, sticky='ew', columnspan=60)
for setNumber in range(maxset):
    elcol = setNumber * 2
    titleText = 'Set ' + str(setNumber + 1)
    setTitles.append(tk.Label(editSets, text=titleText, fg='#ffffff', bg='#333333', font=ButtonFont))
    setTitles[-1].grid(row=5, column=elcol, sticky='ew', columnspan=2)
for element in setItems:
    songNameIndex = songID.index(element.song)
    tableElements.append(ttk.Combobox(editSets, state='readonly', values=songName))
    tableElements[-1].current(songNameIndex)
    elrow = element.position + 5
    elcol = (element.idset - 1) * 2
    tableElements[-1].grid(row=elrow, column=elcol, sticky='ew', columnspan=2)
editSets.mainloop()
pass