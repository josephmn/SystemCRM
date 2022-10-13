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
    public class CListarUtilidades
    {
        public List<EListarUtilidades> Listar_ListarUtilidades(SqlConnection con, Int32 anhio)
        {
            List<EListarUtilidades> lEListarUtilidades = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_UTILIDADES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@anhio", SqlDbType.Int).Value = anhio;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarUtilidades = new List<EListarUtilidades>();

                EListarUtilidades obEListarUtilidades = null;
                while (drd.Read())
                {
                    obEListarUtilidades = new EListarUtilidades();
                    obEListarUtilidades.ANHIO = drd["ANHIO"].ToString();
                    obEListarUtilidades.PERIODO = drd["PERIODO"].ToString();
                    obEListarUtilidades.PERID = drd["PERID"].ToString();
                    obEListarUtilidades.NOMBRES = drd["NOMBRES"].ToString();
                    obEListarUtilidades.FECHAPAGO = drd["FECHAPAGO"].ToString();
                    lEListarUtilidades.Add(obEListarUtilidades);
                }
                drd.Close();
            }

            return (lEListarUtilidades);
        }
    }
}