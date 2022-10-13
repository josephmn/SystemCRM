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
    public class CSemana
    {
        public List<ESemana> Listar_Semana(SqlConnection con, Int32 post, String user)
        {
            List<ESemana> lESemana = null;
            SqlCommand cmd = new SqlCommand("ASP_SEMANA", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@user", SqlDbType.VarChar).Value = user;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lESemana = new List<ESemana>();

                ESemana obESemana = null;
                while (drd.Read())
                {
                    obESemana = new ESemana();
                    obESemana.i_num_semana = drd["i_num_semana"].ToString();
                    obESemana.v_descripcion = drd["v_descripcion"].ToString();
                    obESemana.i_anhio = drd["i_anhio"].ToString();
                    obESemana.i_select = drd["i_select"].ToString();
                    lESemana.Add(obESemana);
                }
                drd.Close();
            }

            return (lESemana);
        }
    }
}