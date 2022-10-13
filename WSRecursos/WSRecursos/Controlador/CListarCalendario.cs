using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CListarCalendario
    {
        public List<EListarCalendario> Listar_ListarCalendario(SqlConnection con)
        {
            List<EListarCalendario> lEListarCalendario = null;
            SqlCommand cmd = new SqlCommand("ASP_CALENDARIO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarCalendario = new List<EListarCalendario>();

                EListarCalendario obEListarCalendario = null;
                while (drd.Read())
                {
                    obEListarCalendario = new EListarCalendario();
                    obEListarCalendario.title = drd["title"].ToString();
                    obEListarCalendario.start = drd["start"].ToString();
                    obEListarCalendario.end = drd["end"].ToString();
                    obEListarCalendario.backgroundColor = drd["backgroundColor"].ToString();
                    obEListarCalendario.borderColor = drd["borderColor"].ToString();
                    obEListarCalendario.allDay = drd["allDay"].ToString();
                    lEListarCalendario.Add(obEListarCalendario);
                }
                drd.Close();
            }

            return (lEListarCalendario);
        }
    }
}