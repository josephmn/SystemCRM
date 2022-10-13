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
    public class CIndHExMontos
    {
        public List<EIndHExMontos> Listar_IndHExMontos(SqlConnection con)
        {
            List<EIndHExMontos> lEIndHExMontos = null;
            SqlCommand cmd = new SqlCommand("ASP_INDHEXMONTOS", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEIndHExMontos = new List<EIndHExMontos>();

                EIndHExMontos obEIndHExMontos = null;
                while (drd.Read())
                {
                    obEIndHExMontos = new EIndHExMontos();
                    obEIndHExMontos.v_descripcion = drd["v_descripcion"].ToString();
                    obEIndHExMontos.i_he25 = drd["i_he25"].ToString();
                    obEIndHExMontos.i_he35 = drd["i_he35"].ToString();
                    obEIndHExMontos.i_he100 = drd["i_he100"].ToString();
                    obEIndHExMontos.i_heesp = drd["i_heesp"].ToString();
                    lEIndHExMontos.Add(obEIndHExMontos);
                }
                drd.Close();
            }

            return (lEIndHExMontos);
        }
    }
}