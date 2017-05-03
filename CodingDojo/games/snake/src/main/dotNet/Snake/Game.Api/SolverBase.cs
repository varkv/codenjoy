/*-
 * #%L
 * Codenjoy - it's a dojo-like platform from developers to developers.
 * %%
 * Copyright (C) 2016 Codenjoy
 * %%
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public
 * License along with this program.  If not, see
 * <http://www.gnu.org/licenses/gpl-3.0.html>.
 * #L%
 */
﻿using System;

namespace Game.Api
{
    public abstract class SolverBase
    {
        private const string ResponsePrefix = "board=";

        public SolverBase(string host, string userName)
		{
            Host = host;
			UserName = userName;
		}

		public string UserName { get; private set; }
		public string Host { get; private set; }

		/// <summary>
		/// Set this property to true to finish playing
		/// </summary>
		public bool ShouldExit { get; protected set; }

        public void Play()
        {

            var Server = String.Format("ws://{0}/codenjoy-contest/ws", Host);
            var uri = new Uri(Server + "?user=" + Uri.EscapeDataString(UserName));

            using (var ws = new WebSocketSharp.WebSocket(uri.AbsoluteUri))
            {
                ws.OnMessage += (sender, e) =>
                {
                    var response = e.Data;
                    if (!response.StartsWith(ResponsePrefix))
                    {
                        Console.WriteLine("Something strange is happening on the server... Response:\n{0}", response);
                        ShouldExit = true;
                    }
                    else
                    {
                        var boardString = response.Substring(ResponsePrefix.Length);
                        var action = DoMove(new Board(boardString));
                        ws.Send(action);
                    }
                };

                ws.Connect();
                Console.ReadKey(true);
            }
                                   
        }

        protected abstract string DoMove(Board gameBoard);

        protected static string ActionToString(Direction action)
        {
			return action.ToString().ToLower();
		}
    }
}