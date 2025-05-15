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

selShow = sys.argv[1]

setItems = []
maxset = 0
maxsong = [0] * 20

editSets = tk.Tk()
editSets.title('Showname')
editSets.config(bg="#aaaaaa")
# main.geometry("800x600+200+200")
editSets.resizable(False, False)

con = sqlite3.connect('Centerstage.sqlite3')
cur = con.cursor()
for row in cur.execute('SELECT * FROM sets WHERE idshow=' + str(selShow)):
    newItem = selShow(row)
    setItems.append(newItem)
    if newItem.idset > maxset:
        maxset = newItem.idset
    if newItem.position > maxsong[newItem.idset]:
        maxsong[newItem.idset] = newItem.position
con.close()

TitleFont = tk.font.Font(family='Helvetica', size=21, weight='bold')
ButtonFont = tk.font.Font(family='Helvetica', size=15, weight='bold')
ListFont = tk.font.Font(family='Helvetica', size=12)

Title = tk.Label(editSets, text='Edit Sets', fg='#ffff00', bg='#aaaaaa', font=TitleFont, padx=10, pady=10)
Title.grid(row=0, column=0, sticky='ew', columnspan=40)
blankLabel1 = tk.Label(editSets, text='', bg='#aaaaaa')
blankLabel1.grid(row=1, column=0, sticky='ew', columnspan=40)
showLabel1 = tk.Label(editSets, text='Showname:', fg='#00ff00', bg='#aaaaaa', font=ButtonFont)
showLabel1.grid(row=2, column=0, sticky='ew', columnspan=2)
showName = tk.Entry(editSets, textvariable=showNameString, fg='#ff0000', bg='#aaaaaa', font=ButtonFont)
showName.grid(row=3, column=0, sticky='ew', columnspan=2)
blankLabel2 = tk.Label(editSets, text='', bg='#aaaaaa')
blankLabel2.grid(row=4, column=0, sticky='ew', columnspan=2)
button1 = tk.Button(editSets, text=titleText, command=changeName, font=ButtonFont)
button1.grid(row=5, column=0, sticky='ew')
button2 = tk.Button(editSets, text='EditSets', command=editSets, font=ButtonFont)
button2.grid(row=6, column=0, sticky='ew')
button3 = tk.Button(editSets, text='Exit', command=exitEditShow, font=ButtonFont)
button3.grid(row=7, column=0, sticky='ew')

editSets.mainloop()