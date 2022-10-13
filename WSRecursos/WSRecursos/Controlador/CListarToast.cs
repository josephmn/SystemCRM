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
    public class CListarToast
    {
        public List<EListarToast> Listar_ListarToast(SqlConnection con, Int32 post, String dni)
        {
            List<EListarToast> lEListarToast = null;
            SqlCommand cmd = new SqlCommand("ASP_TOASTS_VACACIONES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarToast = new List<EListarToast>();

                EListarToast obEListarToast = null;
                while (drd.Read())
                {
                    obEListarToast = new EListarToast();
                    obEListarToast.id = drd["id"].ToString();
                    obEListarToast.classe = drd["class"].ToString();
                    obEListarToast.title = drd["title"].ToString();
                    obEListarToast.subtitle = drd["subtitle"].ToString();
                    obEListarToast.body = drd["body"].ToString();
                    lEListarToast.Add(obEListarToast);
                }
                drd.Close();
            }

            return (lEListarToast);
        }
    }
}